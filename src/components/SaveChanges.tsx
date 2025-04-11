
import React from 'react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { Save, Loader2 } from 'lucide-react';
import { toast } from '@/hooks/use-toast';

interface SaveChangesProps {
  isSaving: boolean;
  onSave: () => void;
  hasChanges: boolean;
  className?: string;
}

const SaveChanges: React.FC<SaveChangesProps> = ({
  isSaving,
  onSave,
  hasChanges,
  className,
}) => {
  const handleSave = () => {
    onSave();
    
    // Show success toast after "saving"
    setTimeout(() => {
      toast({
        title: "Settings saved",
        description: "Your protection settings have been updated.",
      });
    }, 1000);
  };

  return (
    <div className={cn(
      "flex items-center justify-between p-4 border-t bg-[#F9F9F9] rounded-b-lg",
      className
    )}>
      <div className="text-sm text-gray-500">
        {hasChanges ? (
          "You have unsaved changes"
        ) : (
          "All changes saved"
        )}
      </div>
      <Button 
        onClick={handleSave}
        disabled={isSaving || !hasChanges}
        className={cn(
          "bg-gradient-to-r from-[#6a11cb] to-[#2575fc] hover:from-[#5b0fb3] hover:to-[#1e68e6] transition-all duration-200 hover:shadow-md",
          isSaving ? "opacity-80" : "",
          "transform hover:scale-[1.02] active:scale-[0.98]"
        )}
      >
        {isSaving ? (
          <>
            <Loader2 className="mr-2 h-4 w-4 animate-spin" />
            Saving...
          </>
        ) : (
          <>
            <Save className="mr-2 h-4 w-4" />
            Save Changes
          </>
        )}
      </Button>
    </div>
  );
};

export default SaveChanges;
